package com.predictionmarketing.itemrecommender;

import java.io.File;
import java.io.IOException;
import java.util.List;

import org.apache.mahout.cf.taste.common.TasteException;
import org.apache.mahout.cf.taste.impl.common.LongPrimitiveIterator;
import org.apache.mahout.cf.taste.impl.model.file.FileDataModel;
import org.apache.mahout.cf.taste.impl.recommender.GenericItemBasedRecommender;
import org.apache.mahout.cf.taste.impl.similarity.LogLikelihoodSimilarity;
import org.apache.mahout.cf.taste.impl.similarity.PearsonCorrelationSimilarity;
import org.apache.mahout.cf.taste.model.DataModel;
import org.apache.mahout.cf.taste.recommender.RecommendedItem;
import org.apache.mahout.cf.taste.similarity.ItemSimilarity;
import org.apache.mahout.cf.taste.similarity.UserSimilarity;
import org.apache.mahout.math.hadoop.similarity.cooccurrence.measures.EuclideanDistanceSimilarity;



public class ItemRecommender {

	public static void main(String[] args) {
		try {
			
	        DataModel dm = new FileDataModel(new File("data/grand-teton-hiking_trails_rating.csv"));
			//DataModel dm = new FileDataModel(new File("data/glacier_park_hike_trails_ratings.csv"));
			ItemSimilarity sim = new LogLikelihoodSimilarity(dm);
			//ItemSimilarity sim = new PearsonCorrelationSimilarity(dm);
			//ItemSimilarity sim = new ETanimotoCoefficientSimilarity(dm);
			GenericItemBasedRecommender recommender = new GenericItemBasedRecommender(dm, sim);
			
			int x=1;
			for(LongPrimitiveIterator items = dm.getItemIDs(); items.hasNext();) {
				long itemId = items.nextLong();
				List<RecommendedItem>recommendations = recommender.mostSimilarItems(itemId, 5);
				
				for(RecommendedItem recommendation : recommendations) {
					System.out.println(itemId + "," + recommendation.getItemID() + "," + recommendation.getValue());
				}
				//x++;
				//if(x>60) System.exit(1);
			
			}
			
			
		} catch (IOException e) {
			System.out.println("There was an error.");
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (TasteException e) {
			System.out.println("There was a Taste Exception");
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}
	
}
